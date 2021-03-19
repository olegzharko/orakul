/* eslint-disable consistent-return */
import { Dispatch } from 'react';
import { NewCard } from '../../types';
import { State } from '../types';
import createNewCardService from '../../services/createNewCard';
import editCalendarCardService from '../../services/editCalendarCard';
import getAppointments from '../../services/getAppointments';
import setSchedulerFilter from '../../services/setSchedulerFilter';
import getCalendarCard from '../../services/getCalendarCard';
import getDeveloperInfo from '../../services/getDeveloperInfo';
import getSchedulerFilter from '../../services/getSchedulerFilter';
import getCalendar from '../../services/getCalendar';
import moveCalendarCardService from '../../services/moveCalendarCard';
import searchAppointmentsServices from '../../services/searchAppointments';

export const ACTIONS = {
  SET_OPTIONS: 'SET_OPTIONS',
  SET_APPOINTMENTS: 'SET_APPOINTMENTS',
  SET_DEVELOPERS_INFO: 'SET_DEVELOPERS_INFO',
  SET_SELECTED_NEW_APPOINTMENT: 'SET_SELECTED_NEW_APPOINTMENT',
  SET_SELECTED_OLD_APPOINTMENT: 'SET_SELECTED_OLD_APPOINTMENT',
  SET_EDIT_APPOINTMENT_DATA: 'SET_EDIT_APPOINTMENT_DATA',
  SET_IS_LOADING: 'SET_IS_LOADING',
  ADD_NEW_APPOINTMENT: 'ADD_NEW_APPOINTMENT',
  SET_MODAL_INFO: 'SET_MODAL_INFO',
  EDIT_APPOINTMENTS: 'EDIT_APPOINTMENTS',
  SET_FILTER_INITIAL_DATA: 'SET_FILTER_INITIAL_DATA',
  SET_SCHEDULER_LOCK: 'SET_SCHEDULER_LOCK',
};

export const setSchedulerOptions = (payload: any) => ({
  type: ACTIONS.SET_OPTIONS,
  payload,
});

export const setAppointments = (payload: any) => ({
  type: ACTIONS.SET_APPOINTMENTS,
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

export const addNewAppointment = (payload: any) => ({
  type: ACTIONS.ADD_NEW_APPOINTMENT,
  payload,
});

export const setEditAppointmentData = (payload: any) => ({
  type: ACTIONS.SET_EDIT_APPOINTMENT_DATA,
  payload,
});

export const setEditAppointmens = (payload: any) => ({
  type: ACTIONS.EDIT_APPOINTMENTS,
  payload,
});

export const setModalInfo = (payload: any) => ({
  type: ACTIONS.SET_MODAL_INFO,
  payload,
});

export const setFilterInitialData = (payload: any) => ({
  type: ACTIONS.SET_FILTER_INITIAL_DATA,
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
export const createNewCard = (data: NewCard) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main;

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

export const editCalendarCard = (bodyData: NewCard, id: number) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main;

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
      dispatch(setEditAppointmens(data));
    }
  }
};

export const fetchAppointments = () => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main;

  if (token) {
    dispatch(setIsLoading(true));
    const data = await getAppointments(token);

    dispatch(setAppointments(Object.values(data)));
    dispatch(setIsLoading(false));
  }
};

export const fetchAppointmentsByFilter = (bodyData: any) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main;

  if (token) {
    const { data, success } = await setSchedulerFilter(token, bodyData);

    if (success) {
      dispatch(setAppointments(Object.values(data)));
    }
  }
};

export const fetchCalendarCard = (id: string) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main;

  if (token) {
    const data = await getCalendarCard(token, id);
    dispatch(setEditAppointmentData(data));
  }
};

export const fetchDeveloperInfo = (
  id: number,
  notDispatch: boolean = false
) => async (dispatch: Dispatch<any>, getState: () => State) => {
  const { token } = getState().main;

  if (token) {
    const data = await getDeveloperInfo(token, id);

    if (!notDispatch) {
      dispatch(setDevelopersInfo(data));
    }
  }
};

export const fetchSchedulerFilter = () => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main;

  if (token) {
    const data = await getSchedulerFilter(token);
    dispatch(setFilterInitialData(data));
  }
};

export const fetchSchedulerSettings = () => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main;

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
  const { token } = getState().main;

  if (token) {
    const { success, data } = await moveCalendarCardService(
      token,
      bodyData,
      id
    );

    if (success) {
      dispatch(setEditAppointmens(data));
    }
  }
};

export const searchAppointments = (text: string, page: string) => async (
  dispatch: Dispatch<any>,
  getState: () => State
) => {
  const { token } = getState().main;

  if (token) {
    const { success, data } = await searchAppointmentsServices(token, {
      text,
      page,
    });

    if (success) {
      dispatch(setAppointments(data));
    }
  }
};
