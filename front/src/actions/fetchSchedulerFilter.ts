import getSchedulerFilter from '../services/getSchedulerFilter';
import { setFilterInitialData } from '../store/scheduler/actions';

const fetchSchedulerFilter = async (dispatch: any, token: string) => {
  const data = await getSchedulerFilter(token);
  dispatch(setFilterInitialData(data));
};

export default fetchSchedulerFilter;
