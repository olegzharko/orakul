import { useEffect, useMemo, useState, useCallback } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { SectionCard } from '../../components/Dashboard/components/DashboardSection/DashboardSection';
import { fetchImmovables, fetchDevelopers } from '../../store/registrator/actions';
import { State } from '../../store/types';

/* eslint-disable no-shadow */
export enum RegistratorNavigationTypes {
  DEVELOPER = 'developer',
  IMMOVABLE = 'immovable',
}

export const useRegistratorScreen = () => {
  const dispatch = useDispatch();
  const { isLoading, developers, immovables } = useSelector((state: State) => state.registrator);
  const [selectedNav, setSelectedNav] = useState(RegistratorNavigationTypes.DEVELOPER);
  const [selectedId, setSelectedId] = useState<any>();
  const [trigger, setTrigger] = useState(true);

  const onChangeNav = useCallback((id, type) => {
    setSelectedId(id);
    setSelectedNav(type);
  }, []);

  const triggerNav = useCallback((val) => {
    setSelectedNav(val);
    setTrigger((prev) => !prev);
  }, []);

  const selectedCardData = useMemo(() => {
    if (selectedNav === RegistratorNavigationTypes.IMMOVABLE) {
      return immovables ? immovables.immovables
        .find((item: any) => item.id === Number(selectedId)) : null;
    }

    return developers ? developers.developers
      .find((item: any) => item.id === Number(selectedId)) : null;
  }, [selectedId, developers, immovables]);

  const sections = useMemo(() => {
    let title = '';
    let cards: SectionCard[] = [];

    if (selectedNav === RegistratorNavigationTypes.DEVELOPER) {
      title = developers?.date_info || '';
      cards = (developers?.developers || []).map((item: any) => ({
        id: item.id,
        title: item.title,
        content: [`Дата: ${item.date}`, `Номер: ${item.number}`],
        color: item.color,
      }));
    } else if (selectedNav === RegistratorNavigationTypes.IMMOVABLE) {
      title = immovables?.date_info || '';
      cards = (immovables?.immovables || []).map((item: any) => ({
        id: item.id,
        title: item.title,
        content: [`Дата: ${item.date}`, `Номер: ${item.number}`],
        color: item.color,
      }));
    }

    return [{
      title,
      cards,
    }];
  }, [selectedNav, immovables, developers]);

  useEffect(() => {
    if (selectedNav === RegistratorNavigationTypes.DEVELOPER) {
      dispatch(fetchDevelopers());
    } else {
      dispatch(fetchImmovables());
    }
  }, [trigger, selectedId]);

  return { selectedNav, triggerNav, isLoading, sections, onChangeNav, selectedCardData };
};
