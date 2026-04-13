# -----------------------------------------------------------------------------
# _lib.zsh — Shared library for PHP-Flasher bin/ scripts
#
# Source this file at the top of every script:
#   VERSION="1.0.0"
#   source "${0:A:h}/_lib.zsh"
# -----------------------------------------------------------------------------

set -o pipefail
setopt nullglob 2>/dev/null || true

# SCRIPT_NAME must be set by the caller before sourcing.
# If not set, fall back to the sourcing script's name via ZSH_ARGZERO or $0.
if [[ -z "${SCRIPT_NAME:-}" ]]; then
    SCRIPT_NAME="${ZSH_ARGZERO:t}"
fi
DEBUG=${DEBUG:-0}
QUIET=${QUIET:-0}
DRY_RUN=${DRY_RUN:-0}

# --- Color Definitions ---
if [[ -t 1 ]]; then
    COLOR_RESET=$(tput sgr0); COLOR_BOLD=$(tput bold); COLOR_DIM=$(tput dim)
    COLOR_RED=$(tput setaf 1); COLOR_GREEN=$(tput setaf 2); COLOR_YELLOW=$(tput setaf 3)
    COLOR_BLUE=$(tput setaf 4); COLOR_MAGENTA=$(tput setaf 5); COLOR_CYAN=$(tput setaf 6)
else
    COLOR_RESET=''; COLOR_BOLD=''; COLOR_DIM=''; COLOR_RED=''; COLOR_GREEN=''
    COLOR_YELLOW=''; COLOR_BLUE=''; COLOR_MAGENTA=''; COLOR_CYAN=''
fi

# --- Logging Functions ---
debug_log() { if [[ "$DEBUG" -eq 1 ]]; then echo "${COLOR_DIM}[DEBUG] $1${COLOR_RESET}" >&2; fi; }
info_log()  { if [[ "$QUIET" -eq 0 ]]; then echo "${COLOR_CYAN}[INFO]${COLOR_RESET} $1"; fi; }
warn_log()  { if [[ "$QUIET" -eq 0 ]]; then echo "${COLOR_YELLOW}[WARN]${COLOR_RESET} $1"; fi; }
ok_log()    { if [[ "$QUIET" -eq 0 ]]; then echo "${COLOR_GREEN}[OK]${COLOR_RESET} $1"; fi; }
error_log() { echo "${COLOR_RED}[ERROR]${COLOR_RESET} $1" >&2; }

# --- Command Runner ---
run_cmd() {
    debug_log "Running: $*"
    if [[ "$DRY_RUN" -eq 1 ]]; then
        printf "  ${COLOR_YELLOW}[DRY-RUN]${COLOR_RESET} ${COLOR_DIM}%s${COLOR_RESET}\n" "$*"
        return 0
    fi
    if [[ "$QUIET" -eq 0 ]]; then
        printf "  ${COLOR_BLUE}❯${COLOR_RESET} ${COLOR_DIM}%s${COLOR_RESET}\n" "$*"
        "$@"
    else
        "$@" &>/dev/null
    fi
}

# --- Trap / Cleanup ---
INTERRUPTED=0

trap_interrupt() {
    INTERRUPTED=1
}

cleanup() {
    trap - INT TERM EXIT
    if typeset -f script_cleanup &>/dev/null; then
        script_cleanup
    fi
    if [[ "$INTERRUPTED" -eq 1 ]]; then
        echo ""
        warn_log "Interrupted."
        exit 130
    fi
}

trap trap_interrupt INT TERM
trap cleanup EXIT

# --- Common Flag Parser ---
# Returns 0 if the flag was consumed, 1 if not recognized.
# Scripts call this in their argument loop for each flag.
parse_common_flag() {
    case "$1" in
        -q|--quiet)   QUIET=1; return 0 ;;
        -d|--debug)   DEBUG=1; return 0 ;;
        -n|--dry-run) DRY_RUN=1; return 0 ;;
        -v|--version) echo "${SCRIPT_NAME} version ${VERSION:-unknown}"; exit 0 ;;
        -h|--help)    usage; exit 0 ;;
        *)            return 1 ;;
    esac
}
