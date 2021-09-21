import {
  useMemo,
  useState,
  useCallback,
  useEffect
} from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { State } from '../../../../../../../../store/types';
import {
  setDevelopersInfo,
  setSelectedNewAppointment,
  createNewCard,
  editCalendarCard,
  fetchDeveloperInfo,
  removeCalendarCard,
  startIssuing
} from '../../../../../../../../store/scheduler/actions';
import {
  ClientItem,
  ImmovableItem,
  ImmovableItems,
  NewCard
} from '../../../../../../../../types';

import { clientItem, immovableItem } from './types';

export type Props = {
  selectedCard: any,
  initialValues?: any,
  edit?: boolean,
}

// card process stage
export enum ClientStages {
  isGenerating,
  isReadyToGenerating,
  isEditable,
}

const EDIT_BUTTON_LABELS = {
  [ClientStages.isGenerating]: 'Передано до генерації',
  [ClientStages.isReadyToGenerating]: 'Почати видачу',
  [ClientStages.isEditable]: 'Редагувати',
};

// form mode
enum FormMode {
  create,
  edit,
  view,
}

export const useForm = ({ selectedCard, initialValues, edit }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);
  const { options, developersInfo, isLoading } = useSelector(
    (state: State) => state.scheduler
  );
  const [formMode, setFormMode] = useState<FormMode>(edit ? FormMode.view : FormMode.create);

  // Form State
  const [notary, setNotary] = useState<number | null>(initialValues?.card.notary_id || null);
  const [devCompanyId, setDevCompanyId] = useState<number | null>(null);
  const [devRepresentativeId, setDevRepresentativeId] = useState<number | null>(null);
  const [devManagerId, setDevManagerId] = useState<number | null>(null);
  const [peopleQuantity, setPeopleQuantity] = useState<number>(1);
  const [withChildren, setWithChildren] = useState<boolean>(false);
  const [immovables, setImmovables] = useState<ImmovableItems>([immovableItem]);
  const [clients, setClients] = useState<ClientItem[]>([clientItem]);

  // Form Memo Values
  const shouldLoad = useMemo(() => isLoading || !options, [options, isLoading]);

  const notaries = useMemo(() => options?.form_data.notary, [options]);

  const developers = useMemo(() => options?.form_data.developer, [options]);

  const manager = useMemo(() => developersInfo?.manager || [], [
    developersInfo,
  ]);

  const representative = useMemo(() => developersInfo?.representative || [], [
    developersInfo,
  ]);

  console.log(initialValues);

  const activeAddButton = useMemo(() => Boolean(devCompanyId)
    && immovables.length
    && immovables.every((item: ImmovableItem) => item.building_id && item.imm_number)
    && selectedCard, [devCompanyId, immovables, selectedCard]);

  const clientStage = useMemo(() => {
    const generator_step = initialValues?.card.generator_step;
    const ready = initialValues?.card.ready;

    if (generator_step && !ready) {
      return ClientStages.isGenerating;
    }

    if (generator_step && ready) {
      return ClientStages.isReadyToGenerating;
    }

    return ClientStages.isEditable;
  }, [initialValues]);

  const editButtonLabel = useMemo(() => EDIT_BUTTON_LABELS[clientStage], [clientStage]);

  const isGeneratingStage = useMemo(
    () => clientStage === ClientStages.isGenerating, [clientStage]
  );

  const isFormEditDisabled = useMemo(() => formMode === FormMode.view, [formMode]);

  const isFormDataChangeDisabled = useMemo(
    () => formMode === FormMode.view || clientStage !== ClientStages.isEditable,
    [formMode, clientStage]
  );

  const isReadyToGeneratingStage = useMemo(
    () => clientStage === ClientStages.isReadyToGenerating, [clientStage]
  );

  // Form onChange functions
  const onNotaryChange = useCallback((value) => {
    setNotary(value);
  }, []);

  const onDeveloperChange = useCallback(
    (value) => {
      setDevCompanyId(value);
      setDevManagerId(null);
      setDevRepresentativeId(null);
      setImmovables((prev) => prev.map((item) => ({ ...item, building_id: null })));

      if (!value) {
        dispatch(setDevelopersInfo({}));
      }

      dispatch(fetchDeveloperInfo(value));
    },
    []
  );

  const onRepresentativeChange = useCallback(
    (value) => {
      setDevRepresentativeId(value);
    },
    [devRepresentativeId]
  );

  const onManagerChange = useCallback(
    (value) => {
      setDevManagerId(value);
    },
    [devManagerId]
  );

  const onImmovablesChange = useCallback(
    (index: number, value: any) => {
      immovables[index] = value;
      setImmovables([...immovables]);
    },
    [immovables]
  );

  const onClientsChange = useCallback(
    (index: number, value: ClientItem) => {
      clients[index] = value;
      setClients([...clients]);
    },
    [clients]
  );

  // Form CTA
  const onClearAll = useCallback(() => {
    setNotary(null);
    setDevCompanyId(null);
    setDevRepresentativeId(null);
    setDevManagerId(null);
    setImmovables([immovableItem]);
    setClients([clientItem]);
  }, []);

  const onAddImmovables = useCallback(() => {
    setImmovables([...immovables, immovableItem]);
  }, [immovables]);

  const onRemoveImmovable = useCallback((index: number) => {
    setImmovables((prev) => prev.filter((_, mapIndex) => mapIndex !== index));
  }, [immovables]);

  const onAddClients = useCallback(() => {
    setClients([...clients, clientItem]);
  }, [clients]);

  const onRemoveClient = useCallback((index: number) => {
    setClients((prev) => prev.filter((_, mapIndex) => mapIndex !== index));
  }, [clients]);

  const onFormCreate = useCallback(async () => {
    const date_time = `${selectedCard.year}.${selectedCard.date}. ${selectedCard.time}`;

    const formatImmovables = immovables.map((item: ImmovableItem) => ({
      ...item,
      contract_type_id: item.contract_type_id || options.form_data.immovable_type[0].id,
      imm_type_id: item.imm_type_id || options.form_data.immovable_type[0].id,
    }));

    const data: NewCard = {
      immovables: formatImmovables,
      clients,
      date_time,
      dev_company_id: devCompanyId,
      dev_representative_id: devRepresentativeId,
      dev_manager_id: devManagerId,
      room_id: selectedCard.room,
      notary_id: notary || notaries[0].id,
    };

    if (token) {
      if (edit) {
        await dispatch(editCalendarCard(data, selectedCard.i));
        setFormMode(FormMode.view);
      } else {
        await dispatch(createNewCard(data));
        await dispatch(setSelectedNewAppointment(null));
        onClearAll();
      }
    }
  }, [
    devCompanyId,
    devRepresentativeId,
    devManagerId,
    notary,
    immovables,
    clients,
    edit,
    selectedCard,
  ]);

  const onStageButtonClick = useCallback(() => {
    if (isGeneratingStage) return;

    if (isReadyToGeneratingStage) {
      dispatch(startIssuing({
        card_id: selectedCard.i,
        number_of_people: peopleQuantity,
        children: withChildren,
        room_id: selectedCard.room,
      }));
    }

    setFormMode(FormMode.edit);
  }, [
    isGeneratingStage,
    peopleQuantity,
    withChildren,
    selectedCard,
  ]);

  // Confirm Dialog Props
  const [isConfirmDialogOpen, setIsConfirmDialogOpen] = useState<boolean>(false);

  const confirmDialogContent = useMemo(() => ({
    title: `Видалити картку ${selectedCard?.i}`,
    message: 'Ви впевнені, що бажаєте видалити картку?'
  }), [selectedCard]);

  const onDeleteCardClick = useCallback(() => {
    if (isGeneratingStage) return;
    setIsConfirmDialogOpen(true);
  }, [isGeneratingStage]);

  const onConfirmDialogClose = useCallback(() => {
    setIsConfirmDialogOpen(false);
  }, []);

  const onConfirmDialogAgreed = useCallback(() => {
    dispatch(removeCalendarCard(selectedCard?.i));
  }, [selectedCard, removeCalendarCard]);

  useEffect(() => {
    if (initialValues) {
      setNotary(initialValues.card.notary_id);
      setDevCompanyId(initialValues.card.dev_company_id);
      setDevRepresentativeId(initialValues.card.dev_representative_id);
      setDevManagerId(initialValues.card.dev_manager_id);
      setImmovables(
        initialValues.immovables.length === 0
          ? [immovableItem]
          : initialValues.immovables
      );
      setClients(
        initialValues.clients.length === 0
          ? [clientItem]
          : initialValues.clients
      );
    }

    if (initialValues?.card.dev_company_id) {
      dispatch(fetchDeveloperInfo(initialValues.card.dev_company_id));
    }
  }, [initialValues]);

  return {
    shouldLoad,
    notaries,
    representative,
    developers,
    manager,
    immovables,
    clients,
    activeAddButton,
    isConfirmDialogOpen,
    confirmDialogContent,
    isGeneratingStage,
    editButtonLabel,
    peopleQuantity,
    clientStage,
    isFormDataChangeDisabled,
    isReadyToGeneratingStage,
    isFormEditDisabled,
    withChildren,
    onDeleteCardClick,
    onConfirmDialogClose,
    onConfirmDialogAgreed,
    onNotaryChange,
    onDeveloperChange,
    onRepresentativeChange,
    onManagerChange,
    onImmovablesChange,
    onAddImmovables,
    onRemoveImmovable,
    onRemoveClient,
    onClientsChange,
    onAddClients,
    onClearAll,
    onFormCreate,
    setPeopleQuantity,
    setFormMode,
    onStageButtonClick,
    setWithChildren,
    selectedNotaryId: notary,
    selectedDeveloperId: devCompanyId,
    selectedDevRepresentativeId: devRepresentativeId,
    selectedDevManagerId: devManagerId,
  };
};
