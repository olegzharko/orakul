import { SchedulerState } from './scheduler/store';
import { MainState } from './main/store';

export type REDUX_ACTION = {
  type: string;
  payload: any;
};

export type State = {
  scheduler: SchedulerState;
  main: MainState;
};
