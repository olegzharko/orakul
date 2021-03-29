/* eslint-disable import/no-extraneous-dependencies */
import { combineReducers, createStore, applyMiddleware } from 'redux';
import thunk from 'redux-thunk';
import main from './main/store';
import scheduler from './scheduler/store';
import appointments from './appointments/store';
import filter from './filter/store';
import registrator from './registrator/store';

const reducer = combineReducers({
  main,
  scheduler,
  appointments,
  filter,
  registrator,
});

export default createStore(reducer, applyMiddleware(thunk));
