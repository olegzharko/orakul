import { DEFAULT_URL } from '../Constants';
import requestApi from '../utils/requestApi';

type DeveloperSectionsCard = {
  id: number;
  immovables: string[];
  time: string;
  clients: string[];
}

export type DeveloperSectionsCards = {
  day: string;
  date: string;
  cards: DeveloperSectionsCard[];
}

export default async function getDeveloperCards(token: string) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/developer/representative`,
      headers: { Authorization: `Bearer ${token}` },
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error(err);
    return null;
  }
}
