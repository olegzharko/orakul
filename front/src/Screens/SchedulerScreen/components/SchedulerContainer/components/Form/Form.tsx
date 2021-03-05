import React, { memo } from 'react';
import { v4 as uuidv4 } from 'uuid';
import RadioButtonsGroup from '../../../../../../components/RadioButtonsGroup';
import CustomSelect from '../../../../../../components/CustomSelect';
import Immovable from './components/Immovable';
import './index.scss';
import Clients from './components/Clients/Clients';
import PrimaryButton from '../../../../../../components/PrimaryButton';
import { ImmovableItem, useForm } from './useForm';
import Loader from '../../../../../../components/Loader/Loader';

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
          <img src="/icons/clear.svg" alt="clear icon" className="clear-icon" />
        </div>

        <div className="mv12">
          <RadioButtonsGroup
            buttons={meta.notaries}
            onChange={meta.onNotaryChange}
            initial={meta.selectedNotaryId}
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

        <div className="mv12">
          {meta.initImmovables.map(
            (item: ImmovableItem | object, index: number) => (
              <Immovable
                initValues={item}
                contracts={meta.contracts}
                immovableTypes={meta.immovableTypes}
                building={meta.building}
                index={index}
                key={uuidv4()}
                onChange={meta.onImmovablesChange}
              />
            )
          )}
        </div>

        <div className="mv12">
          <Clients />
        </div>

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
