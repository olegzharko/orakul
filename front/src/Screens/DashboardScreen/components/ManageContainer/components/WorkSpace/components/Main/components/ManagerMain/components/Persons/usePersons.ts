import { useDispatch, useSelector } from 'react-redux';
import { useState, useCallback } from 'react';
import { SelectItem } from '../../../../../../../../../../../../types';
import { ContactPersonInfo } from '../../useManagerMain';
import { State } from '../../../../../../../../../../../../store/types';
import putMainPersons from '../../../../../../../../../../../../services/manager/Main/putMainPersons';
import { setModalInfo } from '../../../../../../../../../../../../store/main/actions';

export type Props = {
  cardId: string;
  contact_person_type?: SelectItem[],
  initialData?: ContactPersonInfo[],
}

type InitialPersonData = {
  person_type: null | string,
  name: null | string,
  phone: null | string,
  email: null | string,
}

const initialPersonData = {
  person_type: null,
  name: null,
  phone: null,
  email: null,
};

export const usePersons = ({ initialData, cardId }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [data, setData] = useState<InitialPersonData[]>(
    initialData?.length ? initialData : [initialPersonData]
  );

  const onDataChange = useCallback((index, value) => {
    data[index] = value;
    setData([...data]);
  }, [data]);

  const onClearAll = useCallback(() => {
    setData([initialPersonData]);
  }, []);

  const onAdd = useCallback(() => {
    setData([...data, initialPersonData]);
  }, [data]);

  const onRemove = useCallback((index) => {
    setData((prev) => prev.filter((_, mapIndex) => mapIndex !== index));
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const res = await putMainPersons(token, cardId, data);

      dispatch(
        setModalInfo({
          open: true,
          success: res?.success,
          message: res?.message,
        })
      );
    }
  }, [token, cardId, data, dispatch]);

  return {
    data,
    onDataChange,
    onClearAll,
    onAdd,
    onRemove,
    onSave,
  };
};
