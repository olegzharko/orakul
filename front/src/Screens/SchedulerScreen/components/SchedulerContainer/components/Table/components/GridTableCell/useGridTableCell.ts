import { useMemo, useCallback } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { State } from '../../../../../../../../store/types';
import formatAppointmentDate from '../../utils/formatAppointmentDate';
import { setSelectedNewAppointment } from '../../../../../../../../store/scheduler/actions';

export type Props = {
  rawsQuantity: number;
  raw: number;
  cell: number;
};

export const useGridTableCell = ({ raw, cell }: Props) => {
  const { options } = useSelector((state: State) => state.scheduler);
  const dispatch = useDispatch();

  const rooms = useMemo(() => options?.rooms, [options]);
  const hours = useMemo(() => options?.work_time, [options]);
  const days = useMemo(() => options?.day_and_date, [options]);

  const onClick = useCallback(() => {
    const payload = formatAppointmentDate(hours, rooms, days, raw, cell);
    dispatch(setSelectedNewAppointment(payload));
  }, [hours, rooms, days, raw, cell]);

  return { onClick };
};