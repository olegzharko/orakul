import { useSelector, useDispatch } from 'react-redux';
import { useCallback, useState, useEffect } from 'react';
import { State } from '../../../../../../../../../../../../../../store/types';
import { setModalInfo } from '../../../../../../../../../../../../../../store/main/actions';
import reqClientCitizenship from '../../../../../../../../../../../../../../services/generator/Client/reqClientCitizenship';

type Citizenships = {
  id: number,
  title: string,
}

type InitialData = {
  citizenships: Citizenships[],
  citizenship_id: number,
}

export type Props = {
  id: string;
  initialData?: InitialData;
}

export const useCitizenship = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [data, setData] = useState<Citizenships[]>([]);
  const [selected, setSelected] = useState<number | string | null>();

  useEffect(() => {
    setData(initialData?.citizenships || []);
    setSelected(initialData?.citizenship_id);
  }, [initialData]);

  const onSave = useCallback(async () => {
    if (token) {
      const { success, message } = await reqClientCitizenship(token, id, 'PUT', { citizenship_id: selected });
      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [selected, token]);

  return {
    data,
    selected,
    setSelected,
    onSave,
  };
};
