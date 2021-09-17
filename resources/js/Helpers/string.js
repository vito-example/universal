/**
 *
 * @param string
 * @param limit
 */
export const stringLimit = (string, limit = 100) => {
    return string.length > limit ? `${string.substring(0, limit)} ...` : string;
}
