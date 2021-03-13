/* eslint-disable prettier/prettier */
import { useSelector, useDispatch } from 'react-redux';
import { useMemo, useState, useEffect } from 'react';
import { State } from '../../../../../../store/types';
import { setModalInfo } from '../../../../../../store/scheduler/actions';

export const useSchedulerForm = () => {
  const [selectedTab, setSelectedTab] = useState(0);

  const dispatch = useDispatch();
  const newSelectedAppointment = useSelector(
    (state: State) => state.scheduler.newSelectedAppointment
  );
  const oldSelectedAppointment = useSelector(
    (state: State) => state.scheduler.oldSelectedAppointment
  );
  const editAppointmentData = useSelector(
    (state: State) => state.scheduler.editAppointmentData
  );

  useEffect(() => {
    setSelectedTab(editAppointmentData ? 1 : 0);
  }, [editAppointmentData]);

  useEffect(() => {
    setSelectedTab(0);
  }, [newSelectedAppointment]);

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

  return {
    newSelectedAppointment,
    oldSelectedAppointment,
    editAppointmentData,
    modalProps,
    selectedTab,
    setSelectedTab
  };
};
