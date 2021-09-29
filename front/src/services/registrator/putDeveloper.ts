import { DEFAULT_URL } from '../Constants';
import requestApi from '../utils/requestApi';

export type EditDeveloperProps = {
  date: string | null,
  number: string,
  pass: boolean,
}

export default async function putDeveloper(
  token: string, id: string, bodyData: EditDeveloperProps
) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/registrator/developer/${id}`,
      headers: { Authorization: `Bearer ${token}` },
      method: 'PUT',
      bodyData,
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error(err);
    return null;
  }
}
