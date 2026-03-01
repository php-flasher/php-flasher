export declare const CLASS_NAMES: {
    readonly container: "fl-container";
    readonly wrapper: "fl-wrapper";
    readonly content: "fl-content";
    readonly message: "fl-message";
    readonly title: "fl-title";
    readonly text: "fl-text";
    readonly icon: "fl-icon";
    readonly iconWrapper: "fl-icon-wrapper";
    readonly actions: "fl-actions";
    readonly close: "fl-close";
    readonly progressBar: "fl-progress-bar";
    readonly progress: "fl-progress";
    readonly show: "fl-show";
    readonly sticky: "fl-sticky";
    readonly rtl: "fl-rtl";
    readonly type: (type: string) => string;
    readonly theme: (name: string) => string;
};
export declare const DEFAULT_TITLES: Record<string, string>;
export declare const DEFAULT_TEXT: {
    readonly dismissButton: "DISMISS";
    readonly closeLabel: (type: string) => string;
};
export declare function capitalizeType(type: string): string;
export declare function getTitle(title: string | undefined, type: string): string;
