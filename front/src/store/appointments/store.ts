import { REDUX_ACTION } from '../types';
import { ACTIONS } from './actions';

export type AppointmentsState = {
  appointments: [];
  isLoading: false;
};

const initialState: AppointmentsState = {
  appointments: [],
  isLoading: false,
};

const reducer = (state = initialState, action: REDUX_ACTION) => {
  switch (action.type) {
    case ACTIONS.SET_LOADING:
      return { ...state, isLoading: action.payload };
    case ACTIONS.SET_APPOINTMENTS:
      return { ...state, appointments: action.payload };
    case ACTIONS.ADD_NEW_APPOINTMENT:
      return {
        ...state,
        appointments: [...state.appointments, action.payload],
      };
    case ACTIONS.EDIT_APPOINTMENTS:
      return {
        ...state,
        appointments: [
          ...state.appointments.filter(
            (item: any) => item.i !== action.payload.i
          ),
          action.payload,
        ],
      };
    default:
      return state;
  }
};

export default reducer;
