import { REDUX_ACTION } from '../types';
import { ACTIONS } from './actions';

export type SchedulerState = {
  options: any;
  appointments: any;
  developersInfo: any;
  newSelectedAppointment: any;
  isLoading: boolean;
};

const initialState: SchedulerState = {
  options: null,
  appointments: [],
  developersInfo: {},
  newSelectedAppointment: null,
  isLoading: false,
};

const reducer = (state = initialState, action: REDUX_ACTION) => {
  switch (action.type) {
    case ACTIONS.SET_OPTIONS:
      return { ...state, options: action.payload };
    case ACTIONS.SET_APPOINTMENTS:
      return { ...state, appointments: action.payload };
    case ACTIONS.SET_DEVELOPERS_INFO:
      return { ...state, developersInfo: action.payload };
    case ACTIONS.SET_IS_LOADING:
      return { ...state, isLoading: action.payload };
    case ACTIONS.SET_SELECTED_NEW_APPOINTMENT:
      return { ...state, newSelectedAppointment: action.payload };
    default:
      return state;
  }
};

export default reducer;
