/* eslint-disable arrow-body-style */

export const checkIsSelected = (newSelectedAppointment: any, row: number, cell: number) => {
  return newSelectedAppointment?.raw === row && newSelectedAppointment?.cell === cell;
};
