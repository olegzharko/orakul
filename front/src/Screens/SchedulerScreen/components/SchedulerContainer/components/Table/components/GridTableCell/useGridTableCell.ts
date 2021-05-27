/* eslint-disable implicit-arrow-linebreak */
/* eslint-disable operator-linebreak */
import { useMemo, useCallback } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import moment from 'moment';
import { State } from '../../../../../../../../store/types';
import formatAppointmentDate from '../../utils/formatAppointmentDate';
import { setSelectedNewAppointment } from '../../../../../../../../store/scheduler/actions';

export type Props = {
  rowsQuantity: number;
  raw: number;
  cell: number;
  selected: boolean;
};

export const useGridTableCell = ({ raw, cell }: Props) => {
  const { options } = useSelector((state: State) => state.scheduler);
  const dispatch = useDispatch();

  const rooms = useMemo(() => options?.rooms, [options]);
  const hours = useMemo(() => options?.work_time, [options]);
  const days = useMemo(() => options?.day_and_date, [options]);

  const onClick = useCallback(() => {
    const payload = formatAppointmentDate(hours, rooms, days, raw, cell);
    const isBefore = moment(
      `${payload.year}.${payload.date}. ${payload.time}`
    ).isBefore(moment());

    if (isBefore) return;
    dispatch(setSelectedNewAppointment({
      ...payload,
      raw,
      cell,
      date: payload.date
    }));
  }, [hours, rooms, days, raw, cell]);

  return { onClick };
};
