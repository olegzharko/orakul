/* eslint-disable indent */
import React, { memo } from 'react';

import RadioButtonsGroup from '../../../../../../../../components/RadioButtonsGroup';
import CustomSelect from '../../../../../../../../components/CustomSelect';
import PrimaryButton from '../../../../../../../../components/PrimaryButton';
import Loader from '../../../../../../../../components/Loader/Loader';
import ConfirmDialog from '../../../../../../../../components/ConfirmDialog';
import CustomInput from '../../../../../../../../components/CustomInput/CustomInput';
import CustomSwitch from '../../../../../../../../components/CustomSwitch';

import ImmovableContainer from './components/ImmovableContainer';
import Clients from './components/Clients/Clients';

import './index.scss';
import { useForm, Props, ClientStages } from './useForm';

const SchedulerForm = (props: Props) => {
  const meta = useForm(props);

  if (meta.shouldLoad) {
    return (
      <div className="schedulerForm">
        <Loader />
      </div>
    );
  }

  return (
    <div className="schedulerForm">
      <div className="schedulerForm__forms">
        <div className="schedulerForm__header">
          <p className="title">
            {meta.isFormDataChangeDisabled
              ? `Запис № ${props.selectedCard.i}`
              : 'Новий запис'}
          </p>
          {meta.isFormDataChangeDisabled ? (
            <img
              src="/images/delete.svg"
              alt="delete"
              className={`clear-icon ${meta.isGeneratingStage ? 'disabled' : ''}`}
              onClick={meta.onDeleteCardClick}
            />
          ) : (
            <img
              src="/images/clear.svg"
              alt="clear"
              className="clear-icon"
              onClick={meta.onClearAll}
            />
          )}
        </div>

        <div className="mv12">
          <RadioButtonsGroup
            buttons={
              meta.isFormDataChangeDisabled
                ? meta.notaries.filter(
                    ({ id }: any) => id === meta.selectedNotaryId
                  )
                : meta.notaries
            }
            onChange={meta.onNotaryChange}
            selected={meta.selectedNotaryId}
            unicId="notaries"
          />
        </div>

        <div className="mv12">
          <CustomSelect
            required
            label="Забудовник"
            data={meta.developers}
            onChange={meta.onDeveloperChange}
            selectedValue={meta.selectedDeveloperId}
            disabled={meta.isFormDataChangeDisabled}
          />
        </div>

        <div className="mv12">
          <CustomSelect
            onChange={meta.onRepresentativeChange}
            data={meta.representative}
            label="Підписант"
            selectedValue={meta.selectedDevRepresentativeId}
            disabled={meta.isFormDataChangeDisabled}
          />
        </div>

        <div className="mv12">
          <CustomSelect
            onChange={meta.onManagerChange}
            data={meta.manager}
            label="Менеджер"
            selectedValue={meta.selectedDevManagerId}
            disabled={meta.isFormDataChangeDisabled}
          />
        </div>

        <ImmovableContainer
          immovables={meta.immovables}
          onChange={meta.onImmovablesChange}
          onAdd={meta.onAddImmovables}
          onRemove={meta.onRemoveImmovable}
          disabled={meta.isFormDataChangeDisabled}
        />

        <Clients
          clients={meta.clients}
          onChange={meta.onClientsChange}
          onAdd={meta.onAddClients}
          onRemove={meta.onRemoveClient}
          disabled={meta.isFormDataChangeDisabled}
        />

        {meta.isVisitInfoFormShow && (
          <>
            <div className="mv12">
              <CustomInput
                required
                label="Кількість людей"
                value={meta.peopleQuantity}
                type="number"
                onChange={(e) => meta.setPeopleQuantity(+e)}
                disabled={meta.isVisionInfoFormShowDisabled}
              />
            </div>

            <div className="mv12">
              <CustomSelect
                required
                onChange={(e) => meta.setRoomId(+e)}
                data={meta.rooms}
                label="Кімната"
                selectedValue={meta.roomId}
                disabled={meta.isVisionInfoFormShowDisabled}
              />
            </div>

            <div className="mv12">
              <CustomSwitch
                label="Діти"
                onChange={(e) => meta.setWithChildren(e)}
                selected={meta.withChildren}
                disabled={meta.isVisionInfoFormShowDisabled}
              />
            </div>
          </>
        )}

        <div className="mv12">
          {meta.isFormEditDisabled && (
            <PrimaryButton
              label={meta.editButtonLabel}
              onClick={meta.onStageButtonClick}
              disabled={meta.isStagingButtonDisabled}
              className="schedulerForm__editButton"
            />
          )}

          {!meta.isFormEditDisabled && (
            <PrimaryButton
              label={`${props.edit ? 'Зберегти' : 'Створити'}`}
              onClick={meta.onFormCreate}
              disabled={!meta.activeAddButton}
            />
          )}
        </div>
      </div>

      <ConfirmDialog
        open={meta.isConfirmDialogOpen}
        title={meta.confirmDialogContent.title}
        message={meta.confirmDialogContent.message}
        handleClose={meta.onConfirmDialogClose}
        handleConfirm={meta.onConfirmDialogAgreed}
      />
    </div>
  );
};

export default memo(SchedulerForm);
