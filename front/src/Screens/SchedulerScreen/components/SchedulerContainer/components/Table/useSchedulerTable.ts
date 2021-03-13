/* eslint-disable object-curly-newline */
/* eslint-disable implicit-arrow-linebreak */
/* eslint-disable import/prefer-default-export */
import { useCallback, useEffect, useMemo } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import fetchAppointments from '../../../../../../actions/fetchAppointments';
import fetchCalendarCard from '../../../../../../actions/fetchCalendarCard';
import fetchSchedulerSettings from '../../../../../../actions/fetchSchedulerSettings';
import { setSelectedOldAppointment } from '../../../../../../store/scheduler/actions';
import { State } from '../../../../../../store/types';
import formatAppointmentDate from './utils/formatAppointmentDate';
import moveCalendarCard from '../../../../../../actions/moveCalendarCard';

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

  const tableRows = useMemo(
    () => new Array(hours?.length * days?.length || 0).fill(1),
    [hours]
  );

  const handleAppointmentDrag = useCallback(
    (appointment) => {
      const { year, date, time, room } = formatAppointmentDate(
        hours,
        rooms,
        days,
        appointment.y,
        appointment.x
      );

      const date_time = `${year}.${date}. ${time}`;

      const data = {
        date_time,
        room_id: room,
      };

      if (token) {
        moveCalendarCard(dispatch, token, data, appointment.i);
      }
    },
    [hours, days, rooms, days]
  );

  const onAppointmentClick = useCallback(
    async ({ x, y, i }: any) => {
      const payload = formatAppointmentDate(hours, rooms, days, y, x);

      if (token) {
        await fetchCalendarCard(dispatch, token, i);
      }

      dispatch(
        setSelectedOldAppointment({
          ...payload,
          i,
        })
      );
    },
    [hours, rooms, days]
  );

  return {
    shouldLoad,
    rooms,
    hours,
    tableRows,
    tableColumns,
    days,
    appointments,
    handleAppointmentDrag,
    onAppointmentClick,
  };
};
