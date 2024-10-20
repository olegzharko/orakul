import { useDispatch } from 'react-redux';
import { useEffect, useState, useCallback, useMemo } from 'react';
import { useParams, useHistory } from 'react-router-dom';
import { RegistratorNavigationTypes } from '../../useRegistratorScreen';
import { editImmovableStatus } from '../../../../store/registrator/actions';
import { CheckBanFieldsData } from '../../../../components/CheckBanFields/CheckBanFields';
import { changeMonthWitDate, formatDate } from '../../../../utils/formatDates';

export type Props = {
  onPathChange: (id: string, type: RegistratorNavigationTypes) => void;
  immovable: any;
}

export const useImmovable = ({ onPathChange, immovable }: Props) => {
  const history = useHistory();
  const { id } = useParams<{ id: string }>();

  const dispatch = useDispatch();

  const [data, setData] = useState<CheckBanFieldsData>({
    date: null,
    number: '',
    pass: false,
  });

  const disableSaveButton = useMemo(() => !data.date || !data.number, [data]);

  const onSave = useCallback(() => {
    dispatch(editImmovableStatus(id, { ...data, date: formatDate(data.date) }));
  }, [data, dispatch, id]);

  const onPrevButtonClick = useCallback(() => {
    if (!immovable.prev) return;

    history.push(`/immovable/${immovable.prev}`);
  }, [history, immovable.prev]);

  const onNextButtonClick = useCallback(() => {
    if (!immovable.next) return;

    history.push(`/immovable/${immovable.next}`);
  }, [history, immovable.next]);

  useEffect(() => {
    setData({
      date: immovable?.date ? changeMonthWitDate(immovable?.date) : null,
      number: immovable?.number || '',
      pass: immovable?.pass || false,
    });
  }, [immovable]);

  useEffect(() => onPathChange(id, RegistratorNavigationTypes.IMMOVABLE), [id, onPathChange]);

  return {
    data,
    disableSaveButton,
    setData,
    onPrevButtonClick,
    onNextButtonClick,
    onSave,
  };
};
