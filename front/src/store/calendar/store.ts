import { REDUX_ACTION } from '../types';
import { ACTIONS } from './actions';

export type CalendarState = {
  options: any;
  isLoading: boolean;
  appointments: any;
};

const initialState: CalendarState = {
  options: null,
  appointments: [],
  isLoading: false,
};

const reducer = (state = initialState, action: REDUX_ACTION) => {
  switch (action.type) {
    case ACTIONS.SET_OPTIONS:
      return { ...state, options: action.payload };
    case ACTIONS.SET_APPOINTMENTS:
      return { ...state, appointments: action.payload };
    case ACTIONS.SET_IS_LOADING:
      return { ...state, isLoading: action.payload };
    default:
      return state;
  }
};

export default reducer;
