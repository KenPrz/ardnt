/**
 * Calculates the relative time between a given date and the current time.
 *
 * @param {string} dateString - The date string to calculate the relative time for.
 * @returns {string} The relative time in a human-readable format.
 */
function getRelativeTime(dateString) {
  const now = new Date();
  const commentDate = new Date(dateString);
  const diffInSeconds = Math.floor((now - commentDate) / 1000);

  if (diffInSeconds < 60) return `${diffInSeconds}s`;
  if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)}m`;
  if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)}h`;
  if (diffInSeconds < 604800) return `${Math.floor(diffInSeconds / 86400)}d`;
  if (diffInSeconds < 2419200)
    return `${Math.floor(diffInSeconds / 604800)}wks`;
  if (diffInSeconds < 29030400)
    return `${Math.floor(diffInSeconds / 2419200)}m`;

  return `${Math.floor(diffInSeconds / 29030400)} years ago`;
}

export default getRelativeTime;
