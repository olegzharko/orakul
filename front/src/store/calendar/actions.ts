export const ACTIONS = {
  SET_OPTIONS: 'SET_OPTIONS',
  SET_IS_LOADING: 'SET_IS_LOADING',
};

export const setCalendarOptions = (payload: any) => ({
  type: ACTIONS.SET_OPTIONS,
  payload,
});

export const setIsLoading = (payload: boolean) => ({
  type: ACTIONS.SET_IS_LOADING,
  payload,
});
