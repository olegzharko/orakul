export const formatDate = (date: Date): string => {
  const day = date.getDate() < 9 ? `0${date.getDate()}` : date.getDate();
  const month = date.getMonth() < 9 ? `0${date.getMonth() + 1}` : date.getMonth() + 1;
  const year = date.getFullYear();
  const hours = date.getHours() < 9 ? `0${date.getHours()}` : date.getHours();
  const minutes = date.getMinutes() < 9 ? `0${date.getMinutes()}` : date.getMinutes();

  return `${day}.${month}.${year} ${hours}:${minutes}`;
};
