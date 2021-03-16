/* eslint-disable import/no-extraneous-dependencies */
import { combineReducers, createStore, applyMiddleware } from 'redux';
import thunk from 'redux-thunk';
import token from './token/store';
import scheduler from './scheduler/store';

const reducer = combineReducers({
  token,
  scheduler,
});

export default createStore(reducer, applyMiddleware(thunk));
