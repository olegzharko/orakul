export const changeMonthWitDate = (date: string): Date => new Date(date && date.replace(/(\d{2}).(\d{2}).(\d{4})/, '$2.$1.$3'));

export const formatDate = (date: Date | null): string | null => {
  if (!date) return null;

  date = new Date(date);

  const day = date.getDate() <= 9 ? `0${date.getDate()}` : date.getDate();
  const month = date.getMonth() < 9 ? `0${date.getMonth() + 1}` : date.getMonth() + 1;
  const year = date.getFullYear();
  const hours = date.getHours() <= 9 ? `0${date.getHours()}` : date.getHours();
  const minutes = date.getMinutes() <= 9 ? `0${date.getMinutes()}` : date.getMinutes();

  return `${day}.${month}.${year} ${hours}:${minutes}`;
};
