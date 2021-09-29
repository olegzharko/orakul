import { DEFAULT_URL } from '../Constants';
import requestApi from '../utils/requestApi';

type BodyData = {
  email: string;
  password: string;
};

export default async function login(bodyData: BodyData) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/login`,
      method: 'POST',
      bodyData,
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error(err);
    return null;
  }
}
