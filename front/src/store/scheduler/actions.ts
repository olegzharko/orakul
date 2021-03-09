export const ACTIONS = {
  SET_OPTIONS: 'SET_OPTIONS',
  SET_APPOINTMENTS: 'SET_APPOINTMENTS',
  SET_DEVELOPERS_INFO: 'SET_DEVELOPERS_INFO',
  SET_SELECTED_NEW_APPOINTMENT: 'SET_SELECTED_NEW_APPOINTMENT',
  SET_IS_LOADING: 'SET_IS_LOADING',
  ADD_NEW_APPOINTMENT: 'ADD_NEW_APPOINTMENT',
  SET_MODAL_INFO: 'SET_MODAL_INFO',
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

export const addNewAppointment = (payload: any) => ({
  type: ACTIONS.ADD_NEW_APPOINTMENT,
  payload,
});

export const setModalInfo = (payload: any) => ({
  type: ACTIONS.SET_MODAL_INFO,
  payload,
});

export const setIsLoading = (payload: boolean) => ({
  type: ACTIONS.SET_IS_LOADING,
  payload,
});
