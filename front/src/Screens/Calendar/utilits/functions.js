/* eslint-disable import/prefer-default-export */

export const getCorrectDate = (current) => {
  let day = new Date().getDate();
  const month = new Date().getMonth() === 12 ? 1 : new Date().getMonth() + 1;

  if (current !== new Date().getDay()) {
    const d = new Date();
    d.setDate(d.getDate() + ((current + 7 - d.getDay()) % 7));
    day = d.getDate();
  }

  return `${day}.${month}`;
};
