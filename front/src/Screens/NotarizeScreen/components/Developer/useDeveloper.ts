import { useDispatch } from 'react-redux';
import { useEffect, useState, useCallback, useMemo } from 'react';
import { useParams, useHistory } from 'react-router-dom';
import { NotarizeNavigationTypes } from '../../useNotarizeScreen';
import { editDeveloperStatus } from '../../../../store/registrator/actions';
import { CheckBanFieldsData } from '../../../../components/CheckBanFields/CheckBanFields';
import { changeMonthWitDate, formatDate } from '../../../../utils/formatDates';

export type Props = {
  onPathChange: (id: string, type: NotarizeNavigationTypes) => void;
  developer: any;
}

export const useDeveloper = ({ onPathChange, developer }: Props) => {
  const history = useHistory();
  const { id } = useParams<{ id: string }>();

  const dispatch = useDispatch();

  const [data, setData] = useState<CheckBanFieldsData>({
    date: new Date(),
    number: '',
    pass: false,
  });

  const disableSaveButton = useMemo(() => !data.date || !data.number, [data]);

  const onSave = useCallback(() => {
    dispatch(editDeveloperStatus(id, { ...data, date: formatDate(data.date) }));
  }, [data, dispatch, id]);

  const onPrevButtonClick = useCallback(() => {
    if (!developer.prev) return;

    history.push(`/developer/${developer?.prev}`);
  }, [developer?.prev, history]);

  const onNextButtonClick = useCallback(() => {
    if (!developer.next) return;

    history.push(`/developer/${developer?.next}`);
  }, [developer?.next, history]);

  useEffect(() => {
    setData({
      date: developer?.date ? changeMonthWitDate(developer?.date) : new Date(),
      number: developer?.number || '',
      pass: developer?.pass || false,
    });
  }, [developer]);

  useEffect(() => onPathChange(id, NotarizeNavigationTypes.DEVELOPER), [id, onPathChange]);

  return {
    data,
    disableSaveButton,
    setData,
    onPrevButtonClick,
    onNextButtonClick,
    onSave,
  };
};
