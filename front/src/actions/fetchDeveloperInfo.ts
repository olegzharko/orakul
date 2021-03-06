import getDeveloperInfo from '../services/getDeveloperInfo';
import { setDevelopersInfo } from '../store/scheduler/actions';

const fetchDeveloperInfo = async (dispatch: any, token: string, id: number) => {
  const data = await getDeveloperInfo(token, id);
  dispatch(setDevelopersInfo(data));
};

export default fetchDeveloperInfo;
