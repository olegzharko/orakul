import { useSelector, useDispatch } from 'react-redux';
import { useCallback, useState, useEffect } from 'react';
import { useParams } from 'react-router-dom'; // Third-party import should come first
import { State } from '../../../../../../../../store/types';
import { setModalInfo } from '../../../../../../../../store/main/actions';
import reqClientCitizenship from '../../../../../../../../services/notarize/Client/reqClientCitizenship';

type Citizenships = {
  id: number,
  title: string,
}

type InitialData = {
  citizenships: Citizenships[],
  citizenship_id: number,
}

export type Props = {
  initialData?: InitialData;
  headerColor?: string,
  clientType?: string
}

export const useCitizenship = ({ initialData, clientType }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);
  const { id } = useParams<{ id: string }>();

  const [data, setData] = useState<Citizenships[]>([]);
  const [selected, setSelected] = useState<number | string | null>();

  useEffect(() => {
    setData(initialData?.citizenships || []);
    setSelected(initialData?.citizenship_id);
  }, [initialData]);

  const onSave = useCallback(async () => {
    if (token && clientType) { // Добавлена проверка на наличие clientType
      const { success, message } = await reqClientCitizenship(token, clientType, id, 'PUT', { citizenship_id: selected });
      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [data, dispatch, clientType, token, selected]);

  return {
    data,
    selected,
    setSelected,
    onSave,
  };
};
