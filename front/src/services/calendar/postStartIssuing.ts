import { DEFAULT_URL } from '../Constants';
import requestApi from '../utils/requestApi';

export type PostStartIssuingProps = {
  card_id: string;
  number_of_people: number;
  children: boolean;
  room_id: number;
}

export default async function postStartIssuing(token: string, bodyData: PostStartIssuingProps) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/deal/set/info`,
      headers: { Authorization: `Bearer ${token}` },
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
