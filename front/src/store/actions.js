export const ACTIONS = {
  SET_TOKEN: 'SET_TOKEN',
  SET_LAYOUTS: 'SET_LAYOUTS',
  SET_CURRENT_APPOINTMENT: 'SET_CURRENT_APPOINTMENT',
};

export const setToken = (payload) => ({ type: ACTIONS.SET_TOKEN, payload });
export const setLayouts = (payload) => ({ type: ACTIONS.SET_LAYOUTS, payload });
export const setCurrentAppointment = (payload) => ({
  type: ACTIONS.SET_CURRENT_APPOINTMENT,
  payload,
});
