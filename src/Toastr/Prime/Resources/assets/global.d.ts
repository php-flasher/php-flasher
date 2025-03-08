/**
 * @file TypeScript Global Declarations for Toastr
 * @description Type definitions for jQuery and Toastr globals
 * @author yoeunes
 */

// Declare jQuery on the global window object
interface Window {
    jQuery?: any
    $?: any
    toastr?: any
}
