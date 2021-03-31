import { useDispatch } from 'react-redux';
import { useEffect, useState, useCallback, useMemo } from 'react';
import { useParams, useHistory } from 'react-router-dom';
import { RegistratorNavigationTypes } from '../../useRegistratorScreen';
import { editDeveloperStatus } from '../../../../store/registrator/actions';
import { formatDate } from '../../utils';

export type Props = {
  onPathChange: (id: string, type: RegistratorNavigationTypes) => void;
  developer: any;
}

export type DeveloperCardState = {
  date: Date,
  number: string,
  pass: boolean,
}

export const useDeveloper = ({ onPathChange, developer }: Props) => {
  const history = useHistory();
  const { id } = useParams<{ id: string }>();

  const dispatch = useDispatch();

  const [data, setData] = useState<DeveloperCardState>({
    date: new Date(),
    number: '',
    pass: false,
  });

  const disableSaveButton = useMemo(() => !data.date || !data.number, [data]);

  const onSave = useCallback(() => {
    dispatch(editDeveloperStatus(id, { ...data, date: formatDate(data.date) }));
  }, [data, id]);

  const onPrevButtonClick = useCallback(() => {
    if (!developer.prev) return;

    history.push(`/developer/${developer.prev}`);
  }, [developer]);

  const onNextButtonClick = useCallback(() => {
    if (!developer.next) return;

    history.push(`/developer/${developer.next}`);
  }, [developer]);

  useEffect(() => {
    setData({
      date: new Date(),
      number: '',
      pass: false,
    });
  }, [id]);

  useEffect(() => onPathChange(id, RegistratorNavigationTypes.DEVELOPER), [id]);

  return {
    data,
    disableSaveButton,
    setData,
    onPrevButtonClick,
    onNextButtonClick,
    onSave,
  };
};
