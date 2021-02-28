export const ACTIONS = {
  SET_TOKEN: 'SET_TOKEN',
};

export const setToken = (payload: string) => ({
  type: ACTIONS.SET_TOKEN,
  payload,
});
