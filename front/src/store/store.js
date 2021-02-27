import { createStore } from 'redux';
import { ACTIONS } from './actions';

const initialState = {
  token: null,
  layouts: [],
  currentAppointment: null,
};

const reducer = (state = initialState, action) => {
  switch (action.type) {
    case ACTIONS.SET_TOKEN:
      return { ...state, token: action.payload };
    case ACTIONS.SET_LAYOUTS:
      return { ...state, layouts: action.payload };
    case ACTIONS.SET_CURRENT_APPOINTMENT:
      return { ...state, currentAppointment: action.payload };
    default:
      return state;
  }
};

export default createStore(reducer, initialState);
