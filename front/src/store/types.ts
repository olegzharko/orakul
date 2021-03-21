import { SchedulerState } from './scheduler/store';
import { MainState } from './main/store';
import { AppointmentsState } from './appointments/store';

export type REDUX_ACTION = {
  type: string;
  payload: any;
};

export type State = {
  scheduler: SchedulerState;
  main: MainState;
  appointments: AppointmentsState;
};
