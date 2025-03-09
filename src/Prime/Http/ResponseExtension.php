<?php

declare(strict_types=1);

namespace Flasher\Prime\Http;

use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Http\Csp\ContentSecurityPolicyHandlerInterface;
use Flasher\Prime\Response\Presenter\HtmlPresenter;

/**
 * ResponseExtension - Injects notification HTML into HTTP responses.
 *
 * This class is responsible for injecting the HTML for notifications into HTTP responses.
 * It handles the placement of notification code at appropriate injection points in HTML
 * responses, manages Content Security Policy headers, and ensures that notifications are
 * only injected in suitable responses.
 *
 * Design patterns:
 * - Decorator: Enhances HTTP responses by adding notification HTML
 * - Chain of Responsibility: Determines whether each response is suitable for modification
 */
final readonly class ResponseExtension implements ResponseExtensionInterface
{
    /**
     * Creates a new ResponseExtension instance.
     *
     * @param FlasherInterface                      $flasher       The flasher service for rendering notifications
     * @param ContentSecurityPolicyHandlerInterface $cspHandler    The CSP handler for managing security headers
     * @param list<non-empty-string>                $excludedPaths Regex patterns for paths where notifications shouldn't be rendered
     */
    public function __construct(
        private FlasherInterface $flasher,
        private ContentSecurityPolicyHandlerInterface $cspHandler,
        private array $excludedPaths = [],
    ) {
    }

    /**
     * {@inheritdoc}
     *
     * This method:
     * 1. Checks if the response is eligible for notification injection
     * 2. Finds an appropriate insertion point in the HTML
     * 3. Updates CSP headers if needed
     * 4. Renders the notification HTML
     * 5. Injects the rendered HTML into the response
     */
    public function render(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if (!$this->isRenderable($request, $response)) {
            return $response;
        }

        $content = $response->getContent();

        $placeHolders = [
            HtmlPresenter::FLASHER_REPLACE_ME,
            HtmlPresenter::HEAD_END_PLACE_HOLDER,
            HtmlPresenter::BODY_END_PLACE_HOLDER,
        ];

        foreach ($placeHolders as $insertPlaceHolder) {
            $insertPosition = strripos($content, $insertPlaceHolder);
            if (false !== $insertPosition) {
                break;
            }
        }

        if (false === $insertPosition) {
            return $response;
        }

        $alreadyRendered = HtmlPresenter::FLASHER_REPLACE_ME === $insertPlaceHolder;
        $nonces = $this->cspHandler->updateResponseHeaders($request, $response);

        $context = [
            'envelopes_only' => $alreadyRendered,
            'csp_script_nonce' => $nonces['csp_script_nonce'] ?? null,
            'csp_style_nonce' => $nonces['csp_style_nonce'] ?? null,
        ];

        $htmlResponse = $this->flasher->render('html', [], $context);

        if (empty($htmlResponse)) {
            return $response;
        }

        if ($alreadyRendered) {
            $htmlResponse = \sprintf('options.push(%s);', $htmlResponse);
        }

        // $htmlResponse = "\n".str_replace("\n", '', (string) $htmlResponse)."\n";
        $htmlResponse .= "\n";

        $content = substr($content, 0, $insertPosition).$htmlResponse.substr($content, $insertPosition);
        $response->setContent($content);

        return $response;
    }

    /**
     * Determines if a response is eligible for notification rendering.
     *
     * A response is renderable if:
     * - The request path is not excluded
     * - It's not an AJAX request
     * - It's an HTML request format
     * - The response is HTML
     * - The response is successful (2XX)
     * - It's not a redirection
     * - It's not an attachment
     * - It's not JSON
     *
     * @param RequestInterface  $request  The request
     * @param ResponseInterface $response The response
     *
     * @return bool True if notifications should be rendered in this response
     */
    private function isRenderable(RequestInterface $request, ResponseInterface $response): bool
    {
        return !$this->isPathExcluded($request)
            && !$request->isXmlHttpRequest()
            && $request->isHtmlRequestFormat()
            && $response->isHtml()
            && $response->isSuccessful()
            && !$response->isRedirection()
            && !$response->isAttachment()
            && !$response->isJson();
    }

    /**
     * Checks if the current request path is excluded from notification rendering.
     *
     * @param RequestInterface $request The request
     *
     * @return bool True if the path is excluded
     */
    private function isPathExcluded(RequestInterface $request): bool
    {
        if (!method_exists($request, 'getUri')) { // @phpstan-ignore-line
            return false;
        }

        $url = $request->getUri();

        foreach ($this->excludedPaths as $regexPattern) {
            if (preg_match($regexPattern, $url)) {
                return true;
            }
        }

        return false;
    }
}
