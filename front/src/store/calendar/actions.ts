export const ACTIONS = {
  SET_OPTIONS: 'SET_OPTIONS',
  SET_APPOINTMENTS: 'SET_APPOINTMENTS',
  SET_IS_LOADING: 'SET_IS_LOADING',
};

export const setSchedulerOptions = (payload: any) => ({
  type: ACTIONS.SET_OPTIONS,
  payload,
});

export const setAppointments = (payload: any) => ({
  type: ACTIONS.SET_APPOINTMENTS,
  payload,
});

export const setIsLoading = (payload: boolean) => ({
  type: ACTIONS.SET_IS_LOADING,
  payload,
});
