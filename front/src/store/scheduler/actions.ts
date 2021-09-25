import { Dispatch } from 'react';

import { NewCard } from '../../types';
import createNewCardService from '../../services/calendar/createNewCard';
import editCalendarCardService from '../../services/calendar/editCalendarCard';
import getCalendarCard from '../../services/calendar/getCalendarCard';
import getDeveloperInfo from '../../services/getDeveloperInfo';
import getCalendar from '../../services/calendar/getCalendar';
import moveCalendarCardService from '../../services/calendar/moveCalendarCard';
import deleteCalendarCard from '../../services/calendar/deleteCalendarCard';

import { setModalInfo } from '../main/actions';
import { addNewAppointment, deleteAppointment, setEditAppointments } from '../appointments/actions';
import { State } from '../types';
import postStartIssuing, { PostStartIssuingProps } from '../../services/calendar/postStartIssuing';

export const ACTIONS = {
  SET_OPTIONS: 'SET_OPTIONS',
  SET_DEVELOPERS_INFO: 'SET_DEVELOPERS_INFO',
  SET_SELECTED_NEW_APPOINTMENT: 'SET_SELECTED_NEW_APPOINTMENT',
  SET_SELECTED_OLD_APPOINTMENT: 'SET_SELECTED_OLD_APPOINTMENT',
  SET_EDIT_APPOINTMENT_DATA: 'SET_EDIT_APPOINTMENT_DATA',
  SET_IS_LOADING: 'SET_IS_LOADING',
  SET_SCHEDULER_LOCK: 'SET_SCHEDULER_LOCK',
};

export const setSchedulerOptions = (payload: any) => ({
  type: ACTIONS.SET_OPTIONS,
  payload,
});

export const setDevelopersInfo = (payload: any) => ({
  type: ACTIONS.SET_DEVELOPERS_INFO,
  payload,
});

export const setSelectedNewAppointment = (payload: any) => ({
  type: ACTIONS.SET_SELECTED_NEW_APPOINTMENT,
  payload,
});

export const setSelectedOldAppointment = (payload: any) => ({
  type: ACTIONS.SET_SELECTED_OLD_APPOINTMENT,
  payload,
});

export const setEditAppointmentData = (payload: any) => ({
  type: ACTIONS.SET_EDIT_APPOINTMENT_DATA,
  payload,
});

export const setSchedulerLock = (payload: boolean) => ({
  type: ACTIONS.SET_SCHEDULER_LOCK,
  payload,
});

export const setIsLoading = (payload: boolean) => ({
  type: ACTIONS.SET_IS_LOADING,
  payload,
});

// Thunk actions
export const editCalendarCard = (bodyData: NewCard, id: number) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main.user;

  if (token) {
    const { success, message, data } = await editCalendarCardService(
      token,
      bodyData,
      id
    );

    dispatch(
      setModalInfo({
        open: true,
        success,
        message,
      })
    );

    if (success) {
      dispatch(setEditAppointments(data));
    }
  }
};

export const fetchCalendarCard = (id: string) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main.user;

  if (token) {
    const data = await getCalendarCard(token, id);
    dispatch(setEditAppointmentData(data));
  }
};

export const removeCalendarCard = (id: string) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main.user;

  if (token) {
    const { data, success, message } = await deleteCalendarCard(token, id);

    dispatch(
      setModalInfo({
        open: true,
        success,
        message,
      })
    );

    if (success) {
      dispatch(setSelectedOldAppointment(null));
      dispatch(setEditAppointmentData(null));
      dispatch(deleteAppointment(id));
    }
  }
};

export const fetchDeveloperInfo = (
  id: number,
  notDispatch: boolean = false
) => async (dispatch: Dispatch<any>, getState: () => State) => {
  const { token } = getState().main.user;

  if (token) {
    const data = await getDeveloperInfo(token, id);

    if (!notDispatch) {
      dispatch(setDevelopersInfo(data));
    }
  }
};

export const fetchSchedulerSettings = () => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main.user;

  if (token) {
    dispatch(setIsLoading(true));
    const data = await getCalendar(token);
    dispatch(setSchedulerOptions(data));
    dispatch(setIsLoading(false));
  }
};

export const moveCalendarCard = (
  bodyData: {
    date_time: string;
    room_id: number;
  },
  id: number
) => async (dispatch: Dispatch<any>, getState: () => State) => {
  const { token } = getState().main.user;

  if (token) {
    const { success, data } = await moveCalendarCardService(
      token,
      bodyData,
      id
    );

    if (success) {
      dispatch(setEditAppointments(data));
    }
  }
};

export const createNewCard = (data: NewCard) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main.user;

  if (token) {
    const res = await createNewCardService(token, data);

    dispatch(
      setModalInfo({
        open: true,
        success: res.success,
        message: res.message,
      })
    );

    if (res.success) {
      dispatch(addNewAppointment(res.data));
    }
  }
};

export const startIssuing = (data: PostStartIssuingProps) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main.user;

  if (token) {
    const res = await postStartIssuing(token, data);

    dispatch(
      setModalInfo({
        open: true,
        success: res.success,
        message: res.message,
      })
    );

    if (!res?.success) throw new Error();
  }
};
