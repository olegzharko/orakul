/* eslint-disable jsx-a11y/click-events-have-key-events */
/* eslint-disable jsx-a11y/no-noninteractive-element-interactions */
import React, { memo } from 'react';
import RadioButtonsGroup from '../../../../../../components/RadioButtonsGroup';
import CustomSelect from '../../../../../../components/CustomSelect';
import './index.scss';
import Clients from './components/Clients/Clients';
import PrimaryButton from '../../../../../../components/PrimaryButton';
import Loader from '../../../../../../components/Loader/Loader';
import ImmovableContainer from './components/ImmovableContainer';
import { useForm } from './useForm';

const SchedulerForm = () => {
  const meta = useForm();

  if (meta.shouldLoad) {
    return (
      <div className="scheduler__form schedulerForm">
        <Loader />
      </div>
    );
  }

  return (
    <div className="scheduler__form schedulerForm">
      <div className="schedulerForm__tabs" />
      <div className="schedulerForm__forms">
        <div className="schedulerForm__header">
          <p className="title">Новий запис</p>
          <img
            src="/icons/clear.svg"
            alt="clear icon"
            className="clear-icon"
            onClick={meta.onClearAll}
          />
        </div>

        <div className="mv12">
          <RadioButtonsGroup
            buttons={meta.notaries}
            onChange={meta.onNotaryChange}
            selected={meta.selectedNotaryId}
            unicId="notaries"
          />
        </div>

        <div className="mv12">
          <CustomSelect
            label="Забудовник"
            data={meta.developers}
            onChange={meta.onDeveloperChange}
            selectedValue={meta.selectedDeveloperId}
          />
        </div>

        <div className="mv12">
          <CustomSelect
            onChange={meta.onRepresentativeChange}
            data={meta.representative}
            label="Підписант"
            selectedValue={meta.selectedDevRepresentativeId}
          />
        </div>

        <div className="mv12">
          <CustomSelect
            onChange={meta.onManagerChange}
            data={meta.manager}
            label="Менеджер"
            selectedValue={meta.selecedDevManagerId}
          />
        </div>

        <ImmovableContainer
          immovables={meta.immovables}
          onChange={meta.onImmovablesChange}
          onAdd={meta.onAddImmovables}
        />

        <Clients
          clients={meta.clients}
          onChange={meta.onClientsChange}
          onAdd={meta.onAddClients}
        />

        <div className="mv12">
          <PrimaryButton
            label="Створити"
            onClick={() => console.log('click')}
          />
        </div>
      </div>
    </div>
  );
};

export default memo(SchedulerForm);
