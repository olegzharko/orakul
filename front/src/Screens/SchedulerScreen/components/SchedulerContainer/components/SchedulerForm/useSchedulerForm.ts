/* eslint-disable prettier/prettier */
import { useSelector, useDispatch } from 'react-redux';
import { useMemo } from 'react';
import { State } from '../../../../../../store/types';
import { setModalInfo } from '../../../../../../store/scheduler/actions';

export const useSchedulerForm = () => {
  const dispatch = useDispatch();
  const newSelectedAppointment = useSelector(
    (state: State) => state.scheduler.newSelectedAppointment
  );

  const modalInfo = useSelector((state: State) => state.scheduler.modalInfo);

  const modalProps = useMemo(
    () => ({
      ...modalInfo,
      handleClose: () => dispatch(
        setModalInfo({
          ...modalInfo,
          open: false
        })
      ),
    }),
    [modalInfo]
  );

  return { newSelectedAppointment, modalProps };
};
