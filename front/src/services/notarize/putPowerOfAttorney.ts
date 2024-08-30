import { DEFAULT_URL } from '../Constants';
import requestApi from '../utils/requestApi';

export type EditPowerOfAttorneyProps = {
  date: string | null,
  number: string,
  pass: boolean,
}

export default async function putPowerOfAttorney(
  token: string, id: string, bodyData: EditPowerOfAttorneyProps
) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/notarize/power-of-attorneys/${id}`,
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
