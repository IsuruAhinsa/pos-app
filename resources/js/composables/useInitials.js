/**
 * Generates initials from a full name
 * @param {string} [fullName] - The full name to convert to initials
 * @returns {string} Uppercase initials (e.g., "JS" for "John Smith")
 */
export function getInitials(fullName = '') {
    if (!fullName || typeof fullName !== 'string') return '';

    // Clean and split the name
    const names = fullName
        .trim()
        .split(' ');

    if (names.length === 0) return '';

    // Handle a single name
    if (names.length === 1) {
        return names[0].charAt(0).toUpperCase();
    }

    // Get first and last initials
    const firstInitial = names[0].charAt(0);
    const lastInitial = names[names.length - 1].charAt(0);

    // Return combined initials (up to maxInitials)
    return `${firstInitial}${lastInitial}`.toUpperCase();
}

/**
 * Composable function for generating initials
 * @returns {{ getInitials: Function }} Object containing getInitials function
 */
export function useInitials() {
    return { getInitials };
}
