import { useEffect, useMemo, useState } from 'react';
import { useSelector } from 'react-redux';
import { useParams, useHistory } from 'react-router-dom';
import getMain from '../../../../../../../../../../services/manager/Main/getMain';
import { State } from '../../../../../../../../../../store/types';
import { SelectItem } from '../../../../../../../../../../types';

export type ContactPersonInfo = {
  person_type: string;
  name: string;
  phone: string;
  email: string;
  id?: string;
};

type ManagerMainData = {
  date_info: {
    day: string;
    date: string;
    time: string;
    room: string;
  },
  notary: SelectItem[];
  developer: SelectItem[];
  representative: SelectItem[];
  manager: SelectItem[];
  contact_person_type: SelectItem[];
  contact_person_info: ContactPersonInfo[];
  generator: SelectItem[];
  notary_id: string;
  developer_id: string;
  representative_id: string;
  manager_id: string;
  generator_id: string;
}

export type ManagerParticipantsData = {
  developer: SelectItem[];
  developer_id: string;
  representative: SelectItem[];
  representative_id: string;
  manager: SelectItem[];
  manager_id: string;
  notary: SelectItem[];
  notary_id: string;
  generator: SelectItem[];
  generator_id: string;
}

export const useManagerMain = () => {
  const history = useHistory();
  const { id } = useParams<{id: string}>();
  const { token } = useSelector((state: State) => state.main.user);

  const [isLoading, setIsLoading] = useState<boolean>(false);
  const [data, setData] = useState<ManagerMainData>();
  const [participantsData, setParticipantsData] = useState<ManagerParticipantsData>();
  const [personsData, setPersonsData] = useState<ContactPersonInfo[]>();

  const mainTitle = useMemo(() => `${data?.date_info.day} ${data?.date_info.date} ${data?.date_info.time} ${data?.date_info.room}`, [data]);

  useEffect(() => {
    if (Number.isNaN(parseFloat(id))) {
      history.push('/');
    }

    if (token) {
      // get MAIN_DATA
      (async () => {
        setIsLoading(true);
        const res = await getMain(token, id);

        if (res?.success) {
          setData(res?.data);
          setPersonsData(res?.data.contact_person_info);
          setParticipantsData({
            developer: res?.data.developer || [],
            developer_id: res?.data.developer_id || '',
            representative: res?.data.representative || [],
            representative_id: res?.data.representative_id || '',
            manager: res?.data.manager || [],
            manager_id: res?.data.manager_id || '',
            notary: res?.data.notary || [],
            notary_id: res?.data.notary_id || '',
            generator: res?.data.generator || '',
            generator_id: res?.data.generator_id || '',
          });
        }

        setIsLoading(false);
      })();
    }
  }, [token, id]);

  return {
    id,
    data,
    mainTitle,
    isLoading,
    participantsData,
    personsData,
  };
};
