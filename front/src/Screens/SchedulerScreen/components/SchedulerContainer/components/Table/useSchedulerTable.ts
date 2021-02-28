/* eslint-disable implicit-arrow-linebreak */
/* eslint-disable import/prefer-default-export */
import { useCallback, useEffect, useMemo } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import fetchCalendarData from '../../../../../../actions/fetchCalendarData';

export const useSchedulerTable = () => {
  const dispatch = useDispatch();
  const token = useSelector((state: any) => state.token.token);
  const { options, isLoading } = useSelector((state: any) => state.calendar);

  useEffect(() => {
    if (token && !isLoading) {
      fetchCalendarData(dispatch, token);
    }
  }, [token]);

  const rooms = useMemo(() => options?.rooms, [options]);
  const hours = useMemo(() => options?.work_time, [options]);

  const shouldLoad = useMemo(() => isLoading || !options, [
    isLoading,
    rooms,
    hours,
  ]);

  const tableColumns = useMemo(() => new Array(rooms?.length || 0).fill(1), [
    rooms,
  ]);

  const days = useMemo(() => options?.day_and_date, [options]);

  const tableRaws = useMemo(
    () => new Array(hours?.length * days?.length || 0).fill(1),
    [hours]
  );

  const appointments = useMemo(() => Object.values(options?.contracts || {}), [
    options,
  ]);

  const handleAppointmentDrag = useCallback(
    (appointment) => {
      const { y } = appointment;
      const { day } = days[Math.floor(y / hours.length)];
      const { time } = hours[y % hours.length];
      // eslint-disable-next-line no-console
      console.log(day, time);
    },
    [hours, days]
  );

  return {
    shouldLoad,
    rooms,
    hours,
    tableRaws,
    tableColumns,
    days,
    appointments,
    handleAppointmentDrag,
  };
};
