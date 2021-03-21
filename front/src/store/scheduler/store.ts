import { REDUX_ACTION } from '../types';
import { ACTIONS } from './actions';

export type SchedulerState = {
  options: any;
  developersInfo: any;
  newSelectedAppointment: any;
  oldSelectedAppointment: any;
  editAppointmentData: any;
  isLoading: boolean;
  filterInitialData: any;
  schedulerLock: boolean;
};

const initialState: SchedulerState = {
  options: null,
  developersInfo: {},
  newSelectedAppointment: null,
  oldSelectedAppointment: null,
  editAppointmentData: null,
  isLoading: false,
  filterInitialData: null,
  schedulerLock: true,
};

const reducer = (state = initialState, action: REDUX_ACTION) => {
  switch (action.type) {
    case ACTIONS.SET_OPTIONS:
      return { ...state, options: action.payload };
    case ACTIONS.SET_DEVELOPERS_INFO:
      return { ...state, developersInfo: action.payload };
    case ACTIONS.SET_IS_LOADING:
      return { ...state, isLoading: action.payload };
    case ACTIONS.SET_SELECTED_NEW_APPOINTMENT:
      return { ...state, newSelectedAppointment: action.payload };
    case ACTIONS.SET_SELECTED_OLD_APPOINTMENT:
      return { ...state, oldSelectedAppointment: action.payload };
    case ACTIONS.SET_EDIT_APPOINTMENT_DATA:
      return { ...state, editAppointmentData: action.payload };
    case ACTIONS.SET_FILTER_INITIAL_DATA:
      return { ...state, filterInitialData: action.payload };
    case ACTIONS.SET_SCHEDULER_LOCK:
      return { ...state, schedulerLock: action.payload };
    default:
      return state;
  }
};

export default reducer;
