const formatAppointmentDate = (
  hours: any,
  rooms: any,
  days: any,
  raw: number,
  cell: number
) => {
  const { day, date, year } = days[Math.floor(raw / hours.length)];
  const { time } = hours[raw % hours.length];
  const room = rooms[cell].id;
  return {
    day,
    date,
    year,
    time,
    room,
  };
};

export default formatAppointmentDate;
