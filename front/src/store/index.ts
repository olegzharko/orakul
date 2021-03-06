import { combineReducers, createStore } from 'redux';
import token from './token/store';
import scheduler from './scheduler/store';

const reducer = combineReducers({
  token,
  scheduler,
});

export default createStore(reducer);
