import { combineReducers, createStore } from 'redux';
import token from './token/store';
import calendar from './calendar/store';

const reducer = combineReducers({
  token,
  calendar,
});

export default createStore(reducer);
