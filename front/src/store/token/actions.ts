export const ACTIONS = {
  SET_TOKEN: 'SET_TOKEN',
  SET_LOADING: 'SET_LOADING',
};

export const setToken = (payload: string) => ({
  type: ACTIONS.SET_TOKEN,
  payload,
});
