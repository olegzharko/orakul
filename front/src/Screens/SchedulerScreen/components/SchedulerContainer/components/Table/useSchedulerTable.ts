/* eslint-disable implicit-arrow-linebreak */
/* eslint-disable import/prefer-default-export */
import { useCallback, useEffect, useMemo } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import fetchAppointments from '../../../../../../actions/fetchAppointments';
import fetchSchedulerSettings from '../../../../../../actions/fetchSchedulerSettings';
import { State } from '../../../../../../store/types';

export const useSchedulerTable = () => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.token);
  const { options, isLoading, appointments } = useSelector(
    (state: State) => state.scheduler
  );

  useEffect(() => {
    if (token && !isLoading) {
      fetchSchedulerSettings(dispatch, token);
      fetchAppointments(dispatch, token);
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
