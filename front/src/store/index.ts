import { combineReducers, createStore, applyMiddleware } from 'redux';
import thunk from 'redux-thunk';
import main from './main/store';
import scheduler from './scheduler/store';
import appointments from './appointments/store';
import filter from './filter/store';
import clients from './clients/store';
import immovables from './immovables/store';
import registrator from './registrator/store';
import notarize from './notarize/store';

const reducer = combineReducers({
  main,
  scheduler,
  appointments,
  filter,
  clients,
  immovables,
  registrator,
  notarize,
});

export default createStore(reducer, applyMiddleware(thunk));
