import { DEFAULT_URL } from '../Constants';
import requestApi from '../utils/requestApi';

export type EditDeveloperProps = {
  date: Date,
  number: string,
  pass: boolean,
}

export default async function putImmovable(
  token: string, id: string, bodyData: EditDeveloperProps
) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/registrator/immovable/${id}`,
      headers: { Authorization: `Bearer ${token}` },
      method: 'PUT',
      bodyData,
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.log(err);
    return null;
  }
}
