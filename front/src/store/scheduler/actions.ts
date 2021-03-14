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

export const setIsLoading = (payload: boolean) => ({
  type: ACTIONS.SET_IS_LOADING,
  payload,
});
