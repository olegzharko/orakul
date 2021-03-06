import { SchedulerState } from './scheduler/store';
import { TokenState } from './token/store';

export type REDUX_ACTION = {
  type: string;
  payload: any;
};

export type State = {
  scheduler: SchedulerState;
  token: TokenState;
};
