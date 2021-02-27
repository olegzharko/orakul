import getToken from '../services/getToken';
import { setToken } from '../store/actions';

const fetchTag = async (dispatch: any) => {
  const token = await getToken();
  dispatch(setToken(token));
};

export default fetchTag;
