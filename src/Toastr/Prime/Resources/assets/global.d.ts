/**
 * @file TypeScript Global Declarations for Toastr
 * @description Type definitions for jQuery and Toastr globals
 * @author Younes ENNAJI
 */

// Declare jQuery on the global window object
interface Window {
    jQuery?: any
    $?: any
    toastr?: any
}
